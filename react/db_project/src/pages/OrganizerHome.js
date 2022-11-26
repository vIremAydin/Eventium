import * as React from "react";
import {makeStyles} from "@material-ui/core/styles";
import OrangeButton from "../components/OrangeButton";
import {TextField} from "@material-ui/core";
import {Link} from "react-router-dom";
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';


const useStyles = makeStyles({

    header: {
        backgroundColor: "#FAB288",
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
        marginTop: "50px",
        marginLeft: "50px",
        marginRight: "50px",

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

    bottomButton:{
        display: "flex",
        justifyContent: "center",
        margin:"20px",

    },


});

function createData(name, calories, fat, carbs, protein) {
    return { name, calories, fat, carbs, protein };
}

const rows = [
    createData('Frozen yoghurt', 159, 6.0, 24, 4.0),
    createData('Ice cream sandwich', 237, 9.0, 37, 4.3),
    createData('Eclair', 262, 16.0, 24, 6.0),
    createData('Cupcake', 305, 3.7, 67, 4.3),
    createData('Gingerbread', 356, 16.0, 49, 3.9),
];
const OrganizerHome = () => {
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
                <Link to={"/participantHome"}> <OrangeButton name={"join an event"}/></Link>
            </div>
            <div className={classes.container}>
                <h3>Your Ongoing Events</h3>
                <TableContainer component={Paper}>
                    <Table sx={{ minWidth: 650 }} aria-label="simple table">
                        <TableHead>
                            <TableRow>
                                <TableCell>Title</TableCell>
                                <TableCell align="right">Date</TableCell>
                                <TableCell align="right">Location</TableCell>
                                <TableCell align="right">Participants</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {rows.map((row) => (
                                <TableRow
                                    key={row.name}
                                    sx={{ '&:last-child td, &:last-child th': { border: 0 } }}
                                >
                                    <TableCell component="th" scope="row">
                                        {row.name}
                                    </TableCell>
                                    <TableCell align="right">{row.calories}</TableCell>
                                    <TableCell align="right">{row.fat}</TableCell>
                                    <TableCell align="right">{row.carbs}</TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </TableContainer>

            </div>
            <div className={classes.bottomButton}>
                <OrangeButton name={"create a new event"}/>
            </div>

        </div>


    )

}

export default OrganizerHome;
