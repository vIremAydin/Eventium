
import Login from "./pages/Login";
import {Route, Routes} from "react-router-dom";
import Register from "./pages/Register";
import ParticipantHome from "./pages/ParticipantHome";
function App() {
  return (
    <div className="App">
        <Routes>
            <Route path='/' element={<Login/>}/>
            <Route path='/register' element={<Register/>}/>
            <Route path='/participantHome' element={<ParticipantHome/>}/>

        </Routes>
    </div>
  );
}

export default App;
