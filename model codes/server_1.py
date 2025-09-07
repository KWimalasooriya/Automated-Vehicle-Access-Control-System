import mysql.connector
from mysql.connector import Error
from datetime import datetime

def manage_numberplate_db(numberplate):
    """Connect to the MySQL database, store the number plate in the database."""
    host = "127.0.0.1"
    user = "root"
    password = ""
    database = "numberplate"
    port = 3306

    try:
        connection = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
            port=port
        )
        if connection.is_connected():
            cursor = connection.cursor()
            cursor.execute(f"CREATE DATABASE IF NOT EXISTS {database}")
            connection.database = database

            create_table_query = """
            CREATE TABLE IF NOT EXISTS numberplate (
                id INT AUTO_INCREMENT PRIMARY KEY,
                numberplate TEXT NOT NULL,
                entry_date DATE,
                entry_time TIME
            )
            """
            cursor.execute(create_table_query)

            insert_data_query = """
            INSERT INTO numberplate (numberplate, entry_date, entry_time)
            VALUES (%s, %s, %s)
            """
            current_date = datetime.now().date()
            current_time = datetime.now().time()
            cursor.execute(insert_data_query, (numberplate, current_date, current_time))
            connection.commit()

    except Error as e:
        print(f"Error: '{e}'")
    finally:
        if connection and connection.is_connected():
            cursor.close()
            connection.close()

def check_identity(numberplate):
    """Check if the numberplate exists in the Identities database."""
    try:
        connection = mysql.connector.connect(
            host="127.0.0.1",
            user="root",
            password="",
            database="identities",
            port=3306
        )
        cursor = connection.cursor()
        query = "SELECT owner_name, owner_post FROM details WHERE numberplate = %s"
        cursor.execute(query, (numberplate,))
        result = cursor.fetchone()
        if result:
            return {"status": "Authorized", "name": result[0], "post": result[1]}
        else:
            return {"status": "Unauthorized", "name": "Visitor", "post": ""}
    except Error as e:
        print(f"Error: '{e}'")
        return {"status": "Error", "name": "Unknown", "post": ""}
    finally:
        if connection and connection.is_connected():
            cursor.close()
            connection.close()
