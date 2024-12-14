import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import Navbar from "../components/Navbar";
import { useContext } from "react";
import UserContext from "../components/UserContext";

function BorrowPage() {

    const { book_id } = useParams();
    const { user } = useContext(UserContext);
    const navigate = useNavigate();

    const [borrowDetails, setBorrowDetails] = useState({
        book_id: book_id,
        librarian_id: JSON.parse(user).user.id,
        member_id: "",
        borrow_date: "",
        return_date: ""
    });

    const [bookName, setBookName] = useState("");
    const [members, setMembers] = useState([]);

    useEffect(() => {
        console.log(borrowDetails);
    }, [borrowDetails]);

    const submitDetails = async (e) => {

        e.preventDefault();

        try {
            
            axios.post("http://localhost:8000/api/borrowings/", borrowDetails, {
                headers: {
                    Authorization: `Bearer ${JSON.parse(user).token}`
                }
            }).then(response => {
                navigate("/borrowings");
            }).catch(error => {
                console.log(error);
            });

        } catch (error) {
            console.log(error);
        }

    }

    useEffect(() => {

        if (book_id) {
            
            axios.get(`http://localhost:8000/api/books/${book_id}`, {
                headers: {
                    Authorization: `Bearer ${JSON.parse(user).token}`
                }
            }).then(response => {
                setBookName(response.data.name);
            }).catch(error => {
                console.log(error);
            });

        }

        axios.get("http://localhost:8000/api/members/", {
            headers: {
                Authorization: `Bearer ${JSON.parse(user).token}`
            }
        }).then(response => {
            setMembers(response.data);
        }).catch(error => {
            console.log(error);
        });

    }, [book_id, user]);

    return (
        <>
        <header>
            <Navbar />
        </header>

        <main className="main-login">
            <div className="login-container">
                <h1>Lend to Member</h1>
                <form onSubmit={submitDetails}>
                    <div className="form-group">
                        <label htmlFor="name">Book Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value={bookName}
                            disabled
                            required 
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="memberName">Member Name</label>
                        <select
                            id="memberName"
                            name="memberName"
                            required
                            className="select-input"
                            onChange={(e) => setBorrowDetails({...borrowDetails, member_id: e.target.value})}
                        >
                            <option value="">Select Member</option>
                            {members && members.map(member => <option key={member.member_id} value={member.member_id}>{member.name}</option>)}
                        </select>
                    </div>
                    <div className="form-group">
                        <label htmlFor="dueDate">Borrow Date</label>
                        <input 
                            type="date" 
                            id="dueDate" 
                            name="dueDate" 
                            onChange={(e) => setBorrowDetails({...borrowDetails, borrow_date: e.target.value})}
                            required 
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="returnDate">Return Date</label>
                        <input 
                            type="date" 
                            id="returnDate" 
                            name="returnDate" 
                            onChange={(e) => setBorrowDetails({...borrowDetails, return_date: e.target.value})}
                            required 
                        />
                    </div>
                    <button type="submit">Lend Book</button>
                </form>
            </div>
        </main>
        </>
    );

}

export default BorrowPage;