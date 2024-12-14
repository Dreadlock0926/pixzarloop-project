import { useEffect, useState } from "react";
import Navbar from "../components/Navbar";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import { useContext } from "react";
import UserContext from "../components/UserContext";

function CreateMembers() {

    const { user } = useContext(UserContext);
    const navigate = useNavigate();

    const [memberDetails, setMemberDetails] = useState({
        name: "",
        contact_number: "",
    });

    const submitDetails = async (e) => {

        e.preventDefault();

        try {

            axios.post("http://localhost:8000/api/members/", memberDetails, {
                headers: {
                    Authorization: `Bearer ${JSON.parse(user).token}`
                    }
                }).then(response => {
                    navigate("/library");
                }
                ).catch(error => {
                    console.log(error);
                }

            );

        }
        
        catch (error) {
            console.log(error);
        }

    }


    return (
        <>
        <header>
            <Navbar />
        </header>

        <main className="main-login">
            <div className="login-container">
                <h1>Create Member</h1>
                <form onSubmit={submitDetails}>
                    <div className="form-group">
                        <label htmlFor="name">Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            required 
                            onChange={(e) => setMemberDetails({...memberDetails, name: e.target.value})} 
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="contactNumber">Contact Number</label>
                        <input 
                            type="text" 
                            id="contactNumber" 
                            name="contactNumber" 
                            required 
                            onChange={(e) => setMemberDetails({...memberDetails, contact_number: e.target.value})} 
                        />
                    </div>
                    <button type="submit">Create Member</button>
                </form>
            </div>
        </main>
        </>
    );
}

export default CreateMembers;