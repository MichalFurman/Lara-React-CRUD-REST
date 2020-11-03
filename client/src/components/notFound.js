import React, {Component} from 'react';
import Navbar from './Navbar'
import {gui} from './gui'

export default class notFound extends Component {
  
  componentDidMount(){
    gui.modal('warning','Info','Thats address not exists.')
    this.props.history.push('/')  
  }

  render () {
    return (
      <div>
        <Navbar/>
      <div className="container">
        <div className="jumbotron mt-5">
          <div className="col-sm-8 mx-auto">
            <h1 className="text-center">WELCOME</h1>
          </div>
        </div>
      </div>
      </div>
    )
  }
}
