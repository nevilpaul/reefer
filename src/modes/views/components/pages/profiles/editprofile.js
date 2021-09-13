import React, { Component } from 'react'

export default class ProfileEdit extends Component {
  constructor(props){
    super(props);
  }
  render() {
    const {user} = this.props
    return (
      <div className="col-lg-8">
        <div className="white_card card_height_100 mb_30">
            <div className="white_card_header">
                <div className="white_box_tittle">
                    <h4>Other Profile Details</h4>
                </div>
            </div>
            <div className="white_card_body">
                <div className="row">
                    <div className="col-lg-6">
                        <label >First Name</label>
                        <div className="common_input mb_20">
                            <input type="text" placeholder="Firstname" value={user.firstname} disabled onChange={user.firstname}/>
                        </div>
                    </div>
                    <div className="col-lg-6">
                        <label >Last Name</label>
                          <div className="common_input mb_20">
                              <input type="text" placeholder="Lastname" value={user.lastname} disabled onChange={user.lastname}/>
                          </div>
                    </div>
                    <div className="col-lg-12">
                        <label >Phone Number</label>
                          <div className="common_input mb_20">
                              <input type="text" placeholder="Phone Number" value={user.phone} disabled onChange={user.phone}/>
                          </div>
                    </div>
                    <div className="col-lg-12">
                        <label >Email</label>
                          <div className="common_input mb_20">
                              <input type="text" placeholder="Email" value={user.email}disabled onChange={user.email}/>
                          </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    )
  }
}
