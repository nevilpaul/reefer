import React, { Component } from 'react'
import Withdraw from './wallet/withdraw'
import Quicktransfer from './dashboard/inner/quicktransfer'
import Transaction from './wallet/transactions'
class Wallet extends Component {
  constructor(props){
    super(props);
    this.state ={
      user:{}
    }
  }
  componentDidMount(){
    var title = document.getElementById('title');
    title.innerHTML = `My Wallet | Reefer`;
    this.setState({
      user:this.props.user
    })
  }
  render() {
    const {user} = this.state;
    return (

      <React.Fragment>

        <div className="row">
          <Withdraw user ={user}/>
          <Quicktransfer user ={user}/>
        </div>


      </React.Fragment>
    )
  }
}

export default Wallet;
