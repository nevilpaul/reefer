import React, { Component } from 'react'
import Section from './components/section';
import { BrowserRouter as Router} from "react-router-dom";
class Dynamic extends Component {
  render() {
    return (

      <Router>
        <React.Fragment>

          <Section/>

        </React.Fragment>
      </Router>

    )
  }
}

export default Dynamic;
