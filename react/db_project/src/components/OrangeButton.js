import "./button-style.css"


const OrangeButton = ({name, onClick}) =>{

    return(<div>

                    <button  className={"Active"} onClick={() =>onClick(name)}>{name}
                    </button>

        </div>

    );
}
export default OrangeButton;
