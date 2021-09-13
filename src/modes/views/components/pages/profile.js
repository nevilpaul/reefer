import React, { Component } from 'react'
import User from './profiles/user'
import ProfileEdit from './profiles/editprofile'

class Profile extends Component {
  constructor(props){
    super(props)
    this.state ={
      username:""
    }
    this.charUp=this.charUp.bind(this);
  }
  componentDidMount(){
    var title = document.getElementById('title');
    title.innerHTML = `Profile | Reefer`;

  }
  charUp(letter){
    return(letter.charAt(0).toUpperCase()+letter.slice(1))
  }
  render() {
    const {user} = this.props;
    return (

      <React.Fragment>

        <div className="row">
          <div className="col-12">
              <div className="main-title mb_30">
                  <h3 className="m-0">Welcome Back, { user.username}</h3>
              </div>
          </div>
          <User user={user}/>
          <ProfileEdit user={user}/>
        </div>


      </React.Fragment>
    )
  }
}

export default Profile;
