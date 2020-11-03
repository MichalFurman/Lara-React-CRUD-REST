import React, {Component} from 'react';
import {checkUser} from './UserFunctions'
import Navigation from './Navbar'

export default class Landing extends Component {
  
  componentDidMount(){
    checkUser(this.props, ['all'])
  }

  render () {
    return (
      <div>
        <Navigation/>
      <div className="container">
        <div className="jumbotron mt-4">
          <div className="col-sm-8 mx-auto">
            <h1 className="text-center">WELCOME</h1>
          </div>
        </div>
      </div>
      </div>
    )
  }
}
