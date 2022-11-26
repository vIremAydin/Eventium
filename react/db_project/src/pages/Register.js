import {makeStyles} from "@material-ui/core/styles";
import {Button, MenuItem, TextField} from "@material-ui/core";
import {Link} from "react-router-dom";
import * as React from "react";

import dayjs from 'dayjs';


import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';

import { DesktopDatePicker } from '@mui/x-date-pickers/DesktopDatePicker';

const useStyles = makeStyles({
    loginContainer: {

        margin: "50px",
        display: "flex",
        flexDirection: "column",
        justifyContent: "center",
        alignItems: "center",
        backgroundColor:"rgba(236,74,5,0.66)",
        borderRadius:"20px",

    },

    title: {
        color: "#023047",
        fontSize: "40px",
    },

    textfield: {
        margin: "15px",
        width: "300px"
    },

    registerButton: {
        margin: "20px",
        background: "#023047",
        color: "#ffffff",
    },
    textContainer: {
        display: "flex",
        flexDirection: "column"
    },
    group:{
        display: "flex",
        justifyContent: "space-around"
    },

});


const Register = ({saveUser}) => {
    const classes = useStyles();
    const [firstName, setFirstName] = React.useState('');
    const [lastName, setLastName] = React.useState('');
    const [middleName, setMiddleName] = React.useState('');
    const [password, setPassword] = React.useState('');
    const [city, setCity] = React.useState('');
    const [province, setProvince] = React.useState('');
    const [street, setStreet] = React.useState('');
    const [postalCode, setPostalCode] = React.useState(0);
    const [bdate, setBdate] = React.useState(dayjs('2014-08-18T21:11:54'));
    const [phone, setPhone] = React.useState(0);
    const [email, setEmail] = React.useState("");


    /*
    const handleFirstName = (event) => {
        setFirstName(event.target.value);
    };
    const handleMiddleNAme= (event) => {
        setMiddleName(event.target.value);
    };
    const handleLastN = (event) => {
        setLastName(event.target.value);
    };
    const handleCity = (event) => {
        setCity(event.target.value);
    };
    const handleProv = (event) => {
        setProvince(event.target.value);
    };
    const handleStreet = (event) => {
        setStreet(event.target.value);
    };
    const handlePostal = (event) => {
        setPostalCode(event.target.value);
    };
    const handleBDate = (event) => {
        setBdate(event.target.value);
    };
    async function handleClick() {

        const user = {
            firstName: firstName,
            middleName: middleName,
            lastName: lastName,
            password: password,
            email: email,
            city: city,
            province: province,
            street: street,
            postalCode: postalCode,
            bdate: bdate,

        };*/
    const user = {
        firstName: firstName,
        middleName: middleName,
        lastName: lastName,
        password: password,
        email: email,
        city: city,
        province: province,
        street: street,
        postalCode: postalCode,
        bdate: bdate,
        phone:phone,

    }

    return (
        <div className={classes.loginContainer}>
            <p className={classes.title}>Register</p>
            <div className={classes.textContainer}>
                <div className={classes.group}>
                <TextField onChange={(event) => setEmail(event.target.value)}
                           id="outlined-basic" required label="Email" variant="outlined" className={classes.textfield}/>
                <TextField onChange={(event) => setPassword(event.target.value)}
                           id="outlined-basic" type={"password"} required label="Password" variant="outlined"
                           className={classes.textfield}/>

                </div>
                <div className={classes.group}>
                <TextField onChange={(event) => setFirstName(event.target.value)}
                           id="outlined-basic" required label="Initial name" variant="outlined"
                           className={classes.textfield}/>
                <TextField onChange={(event) => setMiddleName(event.target.value)}
                           id="outlined-basic" label="Middle name" variant="outlined"
                           className={classes.textfield}/>
                <TextField onChange={(event) => setLastName(event.target.value)}
                           id="outlined-basic" required label="Last name" variant="outlined"
                           className={classes.textfield}/>

                </div>
                <div className={classes.group}>
                    <TextField onChange={(event) => setCity(event.target.value)}
                               id="outlined-basic" required label="City" variant="outlined"
                               className={classes.textfield}/>
                    <TextField onChange={(event) => setProvince(event.target.value)}
                               id="outlined-basic" label="Province" variant="outlined"
                               className={classes.textfield}/>
                    <TextField onChange={(event) => setStreet(event.target.value)}
                               id="outlined-basic"  label="Street" variant="outlined"
                               className={classes.textfield}/>

                </div>

                <div className={classes.group}>
                    <TextField onChange={(event) => setPostalCode(event.target.value)}
                               id="outlined-basic"  label="Postal Code" variant="outlined"
                               className={classes.textfield}/>
                    <TextField onChange={(event) => setPhone(event.target.value)}
                               id="outlined-basic" required label="Phone number" variant="outlined"
                               className={classes.textfield}/>
                    <LocalizationProvider dateAdapter={AdapterDayjs}>
                        <DesktopDatePicker
                            label="Birthdate"
                            value={bdate}
                            inputFormat="MM/DD/YYYY"
                            className={classes.textfield}
                            onChange={setBdate}
                            renderInput={(params) => <TextField {...params} />}
                        />
                    </LocalizationProvider>
                </div>
            </div>
               <Button  onClick={()=>console.log(user)} variant="contained"
                                             className={classes.registerButton}>Create an account</Button>
            <p>Already have an account? <Link to={"/"}>Log in</Link></p>
        </div>
    );
}
export default Register;

