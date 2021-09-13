import React, { Component } from 'react'
import Affiliatelist from './affiliate/affiliatelist'
import Levelfour from './affiliate/levelfour';
import Levelone from './affiliate/levelone';
import Levelthree from './affiliate/levelthree';
import Leveltwo from './affiliate/leveltwo';
// import Referallink from './affiliate/referallink';

class Affiliate extends Component {
  constructor(props){
    super(props)
  }
  componentDidMount(){
    var title = document.getElementById('title');
    title.innerHTML = `Affiliate | Reefer`;
  }
  render() {
    const white ={
        color:'white'
    }
    const {username}=this.props.user;
    return (

      <React.Fragment>
          <div className="row">
              <div className="col-12">
                  <div className="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                      <div className="page_title_left d-flex align-items-center">
                          <h3 className="mb-0" >Affiliate</h3>
                      </div>
                  </div>
              </div>
          </div>
          {
          username=='reeferinc'?<div className="row">
          <Levelone color={white} col={3}/>
          <Leveltwo color={white} col={3}/>
          <Levelthree color={white} col={3}/>
          <Levelfour color={white} col={3}/>
          <Affiliatelist/>
        </div>:<div className="row">
            <Levelone color={white} col={4}/>
            <Leveltwo color={white} col={4}/>
            <Levelthree color={white} col={4}/>
            <Affiliatelist/>
          </div>
          }

      </React.Fragment>
    )
  }
}

export default Affiliate;
