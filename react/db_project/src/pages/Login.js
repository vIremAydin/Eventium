import {makeStyles} from "@material-ui/core/styles";
import {Button, TextField} from "@material-ui/core";
import * as React from "react";
import {useEffect} from "react";
import {Alert} from "@mui/material";
import {Link} from "react-router-dom";

const useStyles = makeStyles({
    loginContainer: {
        width: "20%",
        height: "40%",
        marginLeft: "40%",
        marginTop: "5%",
        display: "flex",
        flexDirection: "column",
        justifyContent: "center",
        alignItems: "center"
    },

    title: {
        color: "#a5cce0",
        fontSize: "20px",
    },

    textfield: {
        width: "100%",
        height: "20px",
        borderRadius: "20px",
        marginTop: "20%",
    },

    loginButton: {
        marginTop: "50%",
        width: "100%",
        background: "#66b2d5",
        color: "#ffffff",
        marginBottom: "8%",
    }

});

const Login = () => {
    const classes = useStyles();

    const [id, setId] = React.useState(0);
    const [password, setPassword] = React.useState('');
    const [isSuccessful, setSuccessful] = React.useState(true);
    const [user, setUser] = React.useState(null);

    React.useEffect(() => {

    }, [isSuccessful, id]);

    async function handleClick() {




    }


    return (
        <div className={classes.loginContainer}>{
            isSuccessful ?   (<span/>) :
                <Alert  severity="error">Invalid email or password</Alert>
        }
            <p className={classes.title}>Welcome to Eventium</p>
            <TextField id="outlined-basic" label="E-mail" variant="outlined" className={classes.textfield}
                       onChange={(event) => setId(event.target.value)}/>
            <TextField id="outlined-basic" label="Password" variant="outlined" className={classes.textfield}
                       onChange={(event) => setPassword(event.target.value)}/>

            <Link to={isSuccessful ? "/courses" : "/courses"}/>
            <Button variant="contained"
                    className={classes.loginButton}
                    onClick={() => handleClick()}>
                <Link to={isSuccessful ? "/courses" : "/login"}>Login</Link>
            </Button>
            <p>Forgot Password?</p>

            <Link to={"/register"}>Don't have an account?</Link>
        </div>

    );
}

export default (Login);
