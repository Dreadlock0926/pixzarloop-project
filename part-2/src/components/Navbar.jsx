import "./Navbar.css";
import { Link } from "react-router-dom";

function Navbar() {

  return (
    <nav>
      <ul className="library-navbar">
        <li>
          <Link className="library-navbar-element" to="/library">Library</Link>
        </li>
        <li>
          <Link className="library-navbar-element" to="/borrowings">Borrowings</Link>
        </li>
      </ul>
    </nav>
  );

}

export default Navbar;