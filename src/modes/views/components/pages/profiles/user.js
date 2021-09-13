import React, { Component } from 'react'


class User extends Component {
  constructor(props){
    super(props)

  }

  render() {
    const {user} =this.props;
    return (

      <React.Fragment>

        <div className="col-lg-4 ">
            <div className="white_card card_height_100 mb_30">
                <div className="white_card_header pb-0">
                    <div className="box_header m-0">

                    </div>
                </div>

                <div className="white_card_body">
                  <div className="media mb_30 border_bottom_1px pb-3">
                    <img className="mr-3 rounded-circle mr-0 mr-sm-3" src={`${process.env.PUBLIC_URL}/src/img/transfer/4.png`} alt="" width="60" height="60"/>
                    <div className="media-body">
                        <span>Hello</span>
                        <h4 className="mb-2">{user.username}</h4>
                        <p className="mb-1"> <span><i className="fa fa-phone mr-2 text-primary"></i></span> +{user.phone}</p>
                    </div>
                </div>
                  <ul className="card-profile__info">
                    <li>
                        <h5 className="mr-4">Email</h5>
                        <span className="text-muted"><span><i className="fa fa-envelope mr-2 text-primary"></i></span> {user.email}</span>
                    </li>

                    <li>
                        <h6 className="text-primary mr-4">Account Created</h6>
                        
                        <p className="text-primary">{
                          user.Date_created
                        }</p>
                    </li>
                </ul>
              </div>
            </div>
          </div>


      </React.Fragment>
    )
  }
}

export default User;
