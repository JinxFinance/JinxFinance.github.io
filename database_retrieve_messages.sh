#!/bin/bash

sqlite3 my_database.db <<EOF
SELECT messages.id, messages.customer_name, messages.message
FROM messages
JOIN hotels ON messages.hotel_id = hotels.id
WHERE hotels.name = 'Hotel California';
EOF
