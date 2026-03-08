import json
import mysql.connector

try:
    conn = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="",
        database="terra_database"
    )
    print("✅ Connected!")
except mysql.connector.Error as e:
    print(f"❌ Connection failed: {e}")
# ✅ Load nested JSON
with open('rwanda_nested.json') as f:
    data = json.load(f)

print(f"Provinces found: {len(data['provinces'])}")  # Add this
print(f"Districts found: {sum(len(province['districts']) for province in data['provinces'])}")  # Add this
print(f"Sectors found: {sum(len(district['sectors']) for province in data['provinces'] for district in province['districts'])}")  # Add this

# ✅ Caches to avoid duplicate inserts
cache = {
    'provinces': {},
    'districts': {},
    'sectors': {},
    'cells': {}
}

# ✅ Helper: Get or create record and return its ID
def get_or_create(table, name, parent_column=None, parent_id=None):
    key = f"{name}_{parent_id}" if parent_id else name
    if key in cache[table]:
        return cache[table][key]

    # Check if record exists
    if parent_column:
        cursor.execute(f"SELECT id FROM {table} WHERE name=%s AND {parent_column}=%s", (name, parent_id))
    else:
        cursor.execute(f"SELECT id FROM {table} WHERE name=%s", (name,))
    result = cursor.fetchone()

    if result:
        id = result[0]
    else:
        # Insert new record
        if parent_column:
            cursor.execute(f"INSERT INTO {table} (name, {parent_column}) VALUES (%s, %s)", (name, parent_id))
        else:
            cursor.execute(f"INSERT INTO {table} (name) VALUES (%s)", (name,))
        conn.commit()
        id = cursor.lastrowid

    cache[table][key] = id
    return id

# ✅ Traverse and insert locations
for province in data['provinces']:
    province_id = get_or_create('provinces', province['name'])

    for district in province['districts']:
        district_id = get_or_create('districts', district['name'], 'province_id', province_id)

        for sector in district['sectors']:
            sector_id = get_or_create('sectors', sector['name'], 'district_id', district_id)

            for cell in sector['cells']:
                cell_id = get_or_create('cells', cell['name'], 'sector_id', sector_id)

                for village in cell['villages']:
                    # Handle both string and dict formats
                    village_name = village['name'] if isinstance(village, dict) else village

                    cursor.execute(
                        "SELECT id FROM villages WHERE name=%s AND cell_id=%s",
                        (village_name, cell_id)
                    )
                    if not cursor.fetchone():
                        cursor.execute(
                            "INSERT INTO villages (name, cell_id) VALUES (%s, %s)",
                            (village_name, cell_id)
                        )
                        conn.commit()

# ✅ Close connection
cursor.close()
conn.close()
print("✅ Nested location data imported successfully.")
