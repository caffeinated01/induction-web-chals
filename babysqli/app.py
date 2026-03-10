from flask import Flask, request, render_template
import sqlite3

app = Flask(__name__)


def init_db():
    conn = sqlite3.connect("database.db")
    cur = conn.cursor()
    cur.executescript("""
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY,
            username TEXT,
            password TEXT
        );
        DELETE FROM users;
        INSERT INTO users VALUES (1, 'admin', 'super_secret_password');
        INSERT INTO users VALUES (2, 'alice', 'password123');
        INSERT INTO users VALUES (3, 'bob',   'password456');
    """)
    conn.commit()
    conn.close()


@app.route("/", methods=["GET", "POST"])
def index():
    flag = None
    error = None
    username = ""
    password = ""

    if request.method == "POST":
        username = request.form.get("username", "")
        password = request.form.get("password", "")

        sql = f"SELECT * FROM users WHERE username = '{username}' AND password = '{password}'"

        try:
            con = sqlite3.connect("database.db")
            cur = con.cursor()
            cur.execute(sql)
            row = cur.fetchone()
            con.close()

            if row:
                flag = "CSS{SQLi_1n_th3_b1g_26}"
            else:
                error = "Invalid username or password"
        except Exception as e:
            error = f"SQL Error: {e}"

    return render_template("index.html", username=username, password=password, flag=flag, error=error)


if __name__ == "__main__":
    init_db()
    app.run(host="0.0.0.0", port=5000)
