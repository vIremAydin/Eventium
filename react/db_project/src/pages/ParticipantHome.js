import * as React from "react";
import {makeStyles} from "@material-ui/core/styles";
import OrangeButton from "../components/OrangeButton";

const useStyles = makeStyles({

    header: {
        backgroundColor: "rgba(236,74,5,0.66)",
        width: "100%",
        height: "100px",
        paddingTop: "10px",
        boxSizing: "border-box",
        display: "flex",
        justifyContent: "space-between",
        '& h3': {
            color: "white",
            fontSize: "30px",
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

            backgroundColor: "red",
            borderRadius: "5px",
            borderColor: "red",
            '&:hover': {
                backgroundColor: "rgba(253,13,13,0.66)",
            }
        }
    },


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
                <OrangeButton name={"create an event"}/>
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
