
import Login from "./pages/Login";
import {Route, Routes} from "react-router-dom";
import Register from "./pages/Register";
import ParticipantHome from "./pages/ParticipantHome";
import TicketsPage from "./pages/TicketsPage";
import OrganizerHome from "./pages/OrganizerHome";
function App() {
  return (
    <div className="App">
        <Routes>
            <Route path='/' element={<Login/>}/>
            <Route path='/register' element={<Register/>}/>
            <Route path='/participantHome' element={<ParticipantHome/>}/>
            <Route path='/organizerHome' element={<OrganizerHome/>}/>
            <Route path='/ticketsPage' element={<TicketsPage/>}/>

        </Routes>
    </div>
  );
}

export default App;
