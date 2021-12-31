<?php

declare(strict_types=1);

namespace Infra\EloquentModel\Base;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Exceptions\AuditingException;
use OwenIt\Auditing\Redactors\RightRedactor;

trait AuditableTrait
{
    use Auditable;

    /**
     * Attribute modifiers.
     *
     * @var array
     */
    protected $attributeModifiers = [
        'password' => RightRedactor::class,
        'remember_token' => RightRedactor::class,
    ];

    public function toAudit(): array
    {
        if (!$this->readyForAuditing()) {
            throw new AuditingException('A valid audit event has not been set');
        }

        $attributeGetter = $this->resolveAttributeGetter($this->auditEvent);

        if (!method_exists($this, $attributeGetter)) {
            throw new AuditingException(sprintf(
                'Unable to handle "%s" event, %s() method missing',
                $this->auditEvent,
                $attributeGetter
            ));
        }

        $this->resolveAuditExclusions();

        [$old, $new] = $this->$attributeGetter();

        if ($this->getAttributeModifiers()) {
            foreach ($old as $attribute => $value) {
                $old[$attribute] = $this->modifyAttributeValue($attribute, $value);
            }

            foreach ($new as $attribute => $value) {
                $new[$attribute] = $this->modifyAttributeValue($attribute, $value);
            }
        }

        $tags = implode(',', $this->generateTags());

        $user = $this->resolveUser();

        return $this->transformAudit([
            'old_values'         => $old,
            'new_values'         => $new,
            'conditions'         => null, // eloquentの時はとくになし。queryBuilderのときに使う項目
            'event'              => $this->auditEvent,
            'auditable_id'       => $this->getKey(),
            'auditable_type'     => $this->getTable(),
            'user_id'            => $user ? $user->getAuthIdentifier() : null,
            'user_type'          => $user ? $user->getMorphClass() : null,
            'user_name'          => $user ? $user->getName()->rawValue() : null,
            'url'                => $this->resolveUrl(),
            'ip_address'         => $this->resolveIpAddress(),
            'user_agent'         => $this->resolveUserAgent(),
            'tags'               => empty($tags) ? null : $tags,
        ]);
    }
}
