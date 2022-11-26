import * as React from "react";
import {makeStyles} from "@material-ui/core/styles";
import OrangeButton from "../components/OrangeButton";
import {TextField} from "@material-ui/core";
import {Link} from "react-router-dom";

const useStyles = makeStyles({

    header: {
        backgroundColor: "#DA7840",
        width: "100%",
        height: "100px",
        padding: "10px",
        boxSizing: "border-box",
        display: "flex",
        justifyContent: "space-between",
        '& h3': {
            color: "white",
            fontSize: "39px",
            margin: "20px",
        },
        '& button': {
            marginTop : "20px",

        }
    },

    container: {
        backgroundColor: "lightgray",
        borderRadius: "20px",
        boxSizing: "border-box",
        display: "flex",
        flexDirection: "column",
        padding: "10px",
        margin: "50px",

        '& h3': {

            fontSize: "20px",
        }
    },
    containerItem: {
        display: "flex",
        marginTop: "10px",
        justifyContent: "space-between",
        '& button': {
            cursor: "pointer",
            backgroundColor: "red",
            borderRadius: "5px",
            borderColor: "red",
            '&:hover': {
                backgroundColor: "rgba(253,13,13,0.66)",
            }
        }
    },

    buttons:{
        display: "flex",
        justifyContent:"flex-end",
        marginTop:"10px",
    },

    searchBox:{
        display:"flex",
        justifyContent:"center",
        margin:"20px",
        '& button': {
        marginLeft:"20px",
            height:"30px",
            width:"100px",
            cursor: "pointer",
            backgroundColor: "rgba(168,157,157,0.66)",
            borderRadius: "5px",
            borderColor: "rgba(168,157,157,0.66)",
            '&:hover': {
                backgroundColor: "rgba(203,196,196,0.66)",
            }
        }

    },
    searchBar:{
        width:"300px",
    }


});


const ParticipantHome = () => {
    const classes = useStyles();
    const events = [
        {date: "01-02-2000", content: "welcome party", organizer: "bilkent"},
        {date: "01-02-2020", content: "hello party", organizer: "irem"},
        {date: "01-02-2033", content: "friday party", organizer: "bilka"},

    ]
    return (
        <div>
            <div className={classes.header}>
                <h3>Welcome Irem</h3>
                <Link to={"/organizerHome"}><OrangeButton name={"create an event"}/></Link>
            </div>
            <div className={classes.buttons}>
                <Link to={"/ticketsPage"}><OrangeButton name={"Tickets"}/></Link>
                <OrangeButton name={"Wallet"}/>
            </div>
            <div className={classes.searchBox}>
                <TextField className={classes.searchBar} id="outlined-search"  placeholder="Search an event!" type="search" />
            <button>All events</button>
            </div>
            <div className={classes.container}>
                <h3>Upcoming Events</h3>{
                events.map(event => (
                    <div className={classes.containerItem}>
                        {event.content}
                        <button>cancel</button>
                    </div>
                ))
            }

            </div>


        </div>


    )

}

export default ParticipantHome;
