#!/bin/bash

# Get the directory of the script
SCRIPT_DIR="$(dirname "$(realpath "$0")")"

# Use the script directory to construct the paths
sqlite3 "$SCRIPT_DIR/zusabs.db" < "$SCRIPT_DIR/zusabs.start.sql"
