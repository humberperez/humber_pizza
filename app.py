from flask import Flask, render_template, request, redirect, url_for
import mysql.connector
from mysql.connector import Error

def get_db_connection():
    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="pedidos"
        )
        if connection.is_connected():
            cursor = connection.cursor()
            return connection, cursor
    except Error as e:
        print(f"Error connecting to MySQL: {e}")
        return None, None

app = Flask(__name__)

@app.route("/")
def index():
    return render_template("index.html")

@app.route("/pedidos")
def mostrar_pedidos():
    return render_template("pedidos.html")

@app.route("/guardar_pedido", methods=["POST"])
def guardar_pedido():
    if request.method == "POST":
        nombre = request.form['nombre']
        apellido = request.form['apellido']
        tipo_pizza = request.form['tipo_pizza']
        contacto = request.form['contacto']
        direccion = request.form["direccion"]
        envio = request.form['envio']

        # Establece la conexión con la base de datos
        db_connection, cursor = get_db_connection()
        if db_connection is not None and cursor is not None:
            try:
                # Prepara la consulta SQL
                insert_query = "INSERT INTO pedidos (nombre, apellido, tipo_pizza, contacto, direccion, envio) VALUES (%s, %s, %s, %s, %s, %s)"
                cursor.execute(insert_query, (nombre, apellido, tipo_pizza, contacto, direccion, envio))
                db_connection.commit()
            except Error as e:
                print(f"Error executing query: {e}")
            finally:
                # Cierra la conexión
                cursor.close()
                db_connection.close()

        return redirect(url_for("index"))

if __name__ == "__main__":
    app.run(debug=True)
