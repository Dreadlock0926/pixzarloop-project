import { useState } from "react";
import Navbar from "../components/Navbar";
import "./Login.css";

function Login() {

    const [page, setPage] = useState("login");

    return (
    <>
        <header>
            <Navbar />
        </header>

        <main className="main-login">
            <div className="login-container">
                <h1> {page === "login" ? "Login" : "Register"} </h1>
                <form>
                    <div className="form-group">
                        <label htmlFor="email">Email</label>
                        <input type="email" id="email" name="email" />
                    </div>
                    <div className="form-group">
                        <label htmlFor="password">Password</label>
                        <input type="password" id="password" name="password" />
                    </div>
                    {page !== "login" &&
                    <div className="form-group">
                        <label htmlFor="password">Confirm Password</label>
                        <input type="password" id="password" name="password" />
                    </div>
                    }
                    <button type="submit"> {page === "login" ? "Login" : "Register"} </button>
                </form>
                <div className="login-register">
                    {page === "login" ? 
                    <p>Don't have an account? <span className="login-register-click" onClick={() => setPage("register")}>Register</span></p> :
                    <p>Already have an account? <span className="login-register-click" onClick={() => setPage("login")}>Login</span></p>
                    }
                </div>
            </div>
        </main>
    </>
    )

}

export default Login;