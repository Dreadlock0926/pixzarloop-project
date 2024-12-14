import { useEffect, useState } from "react";
import Navbar from "../components/Navbar";
import "./Login.css";
import axios from "axios";
import UserContext from "../components/UserContext";
import { useContext } from "react";
import { useNavigate } from "react-router-dom";

function Login() {

    const { user, setUser } = useContext(UserContext);
    const navigate = useNavigate();

    if (user) {
        navigate("/library");
    }

    const [page, setPage] = useState("login");
    const [loginRegisterDetails, setLoginRegisterDetails] = useState({
        email: "",
        password: "",
        confirmPassword: "",
        name: "",
    });

    // helper functions
    const login = () => {
        const { email, password } = loginRegisterDetails;
        axios.post("http://localhost:8000/api/login", { email, password })
        .then(res => {
            setUser(res.data);
            navigate("/library");
        })
        .catch(err => {
            console.log(err);
        });
    }

    const register = () => {
        const { email, password, name } = loginRegisterDetails;
        axios.post("http://localhost:8000/api/users", { email, password, name })
        .then(res => {
            setPage("login");
        })
        .catch(err => {
            console.log(err);
        });
    } 

    // submit details
    const submitDetails = async (e) => {
        e.preventDefault();

        if (page === "login") {
            login();
        } else {
            register();
        }

    }

    return (
    <>
        <header>
            <Navbar />
        </header>

        <main className="main-login">
            <div className="login-container">
                <h1> {page === "login" ? "Login" : "Register"} </h1>
                <form onSubmit={submitDetails}>
                    {page !== "login" &&
                    <div className="form-group">
                        <label htmlFor="name">Name</label>
                        <input type="text" id="name" name="name" required onChange={(e) => setLoginRegisterDetails({...loginRegisterDetails, name: e.target.value})} />
                    </div>
                    }
                    <div className="form-group">
                        <label htmlFor="email">Email</label>
                        <input type="email" id="email" name="email" required onChange={(e) => setLoginRegisterDetails({...loginRegisterDetails, email: e.target.value})} />
                    </div>
                    <div className="form-group">
                        <label htmlFor="password">Password</label>
                        <input type="password" id="password" name="password" required onChange={(e) => setLoginRegisterDetails({...loginRegisterDetails, password: e.target.value})} />
                    </div>
                    {page !== "login" &&
                    <div className="form-group">
                        <label htmlFor="password">Confirm Password</label>
                        <input type="password" id="password" name="password" required />
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