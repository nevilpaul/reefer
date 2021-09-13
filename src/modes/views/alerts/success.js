import React,{Component} from 'react'

class Success extends Component {
	constructor(props){
		super(props)
	}
	render(){
		const alertStyle = {
			position:'fixed',
			top:'0px',
			left:'0px',
			position: 'fixed',
		    background: 'white',
		    color: 'black',
		    width: '100%',
		    height: '50px'
		}
		const {Message} = this.props;
		return(
			<div style={alertStyle}>
				<center>
					{Message}
				</center>
			</div>
			);
	}
}

export default Success