import Navbar from "../components/Navbar";
import "./Borrowings.css";
import { FaCheck } from "react-icons/fa";

function Borrowings() {

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
            <tr>
              <td>Book 1</td>
              <td>123456789</td>
              <td>2022-12-31</td>
              <td>John Doe</td>
              {borrowingsType !== "Returned" && <td title="Book returned"><FaCheck className="check-icon"/></td>}
            </tr>
            <tr>
              <td>Book 2</td>
              <td>987654321</td>
              <td>2022-12-31</td>
              <td>Jane Doe</td>
              {borrowingsType !== "Returned" && <td title="Book returned"><FaCheck className="check-icon"/></td>}
            </tr>
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
        <BorrowingsTable borrowingsType="Overdue" />
        <BorrowingsTable borrowingsType="Returned" />
      </main>

    </>
  );
  
}

export default Borrowings;