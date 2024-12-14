import Navbar from "../components/Navbar";
import "./Borrowings.css";
import { FaCheck } from "react-icons/fa";
import { useContext, useEffect, useState } from "react";
import UserContext from "../components/UserContext";
import axios from "axios";

function Borrowings() {

  const { user } = useContext(UserContext);

  const [borrowings, setBorrowings] = useState([]);

  useEffect(() => {

    try {
      axios.get("http://localhost:8000/api/borrowings/", {
        headers: {
          Authorization: `Bearer ${JSON.parse(user).token}`
        }
      }).then(response => {
        setBorrowings(response.data);
        console.log(response.data);
      }
      ).catch(error => {
        console.log(error);
      }
      );

    } catch (error) {
      console.log(error);
    }

  }, [user]);

  function BorrowingsTable({borrowingsType}) {

    return (
      <div className="current-borrowings-container">
        <h2 className="current-borrowings-title">{borrowingsType} Borrowings</h2>
        <table className="current-borrowings">
          <thead>
            <tr>
              <th>Book</th>
              <th>ISBN</th>
              <th>Due Date</th>
              <th>Borrower</th>
              {borrowingsType !== "Returned" && <th>Actions</th>}
            </tr>
          </thead>
          <tbody>
            {borrowings.map((borrowing) => (
              <tr key={borrowing.borrow_id}>
                <td>{borrowing.book.name}</td>
                <td>{borrowing.book.isbn}</td>
                <td>{borrowing.return_date}</td>
                <td>{borrowing.member.name}</td>
                {borrowingsType !== "Returned" && <td><FaCheck className="return-icon" /></td>}
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    )

  }

  return (
    <>

      <header>
        <Navbar />
      </header>

      <main>
        <BorrowingsTable borrowingsType="Current" />
      </main>

    </>
  );
  
}

export default Borrowings;