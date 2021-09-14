import React, { Component } from 'react'
import Quicktransfer from './dashboard/inner/quicktransfer'
import Payments from './payforclient/pay'



class Pay extends Component {
  constructor(props){
    super(props);
    
  }
  componentDidMount(){
    var title = document.getElementById('title');
    title.innerHTML = `Pay Now | Reefer`;
  }
  render() {
    const white ={
        color:'white'
    }
    return (

      <React.Fragment>

          <div className="row">
              <Payments/>
              <Quicktransfer/>
          </div>

      </React.Fragment>
    )
  }
}

export default Pay;
