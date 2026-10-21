#!/bin/sh
set -e

CONTROL_SOCKET="/var/run/control.unit.sock"
STATE_DIR="/var/lib/unit"
CONFIG_DIR="/docker-entrypoint.d"

if [ "$1" = "unitd" ] || [ "$1" = "unitd-debug" ]; then
    if [ -z "$(ls -A "$STATE_DIR" 2>/dev/null)" ]; then
        echo "entrypoint: initial configuration of Unit"

        unitd --control "unix:$CONTROL_SOCKET"
        for _ in $(seq 1 50); do
            [ -S "$CONTROL_SOCKET" ] && break
            sleep 0.1
        done

        for file in "$CONFIG_DIR"/*.json; do
            [ -f "$file" ] || continue
            echo "entrypoint: applying $file"
            response="$(curl -s -X PUT --data-binary "@$file" --unix-socket "$CONTROL_SOCKET" http://localhost/config)"
            echo "$response"
            case "$response" in
                *"Reconfiguration done"*) ;;
                *) echo "entrypoint: failed to apply $file" >&2; exit 1 ;;
            esac
        done

        kill -TERM "$(cat /var/run/unit.pid)"
        for _ in $(seq 1 50); do
            [ -S "$CONTROL_SOCKET" ] || break
            sleep 0.1
        done
        rm -f "$CONTROL_SOCKET"
    else
        echo "entrypoint: state directory is not empty, skipping initial configuration"
    fi
fi

exec "$@"
