import React, {Component} from 'react'
import {getProfile, checkUser} from './UserFunctions'
import Navigation from './Navbar'

export default class Profile extends Component {

  constructor() {
    super()
    this.state = {
      name:'',
      email:'',
      role:''
    }
  }

  componentDidMount(){
    checkUser(this.props, ['all'])    
    getProfile().then(
    response =>{
      if (response) {
        this.setState({
          name: response.data.user.name,
          email: response.data.user.email,
          role: response.data.user.role,
          created: response.data.user.created_at
        })
        localStorage.setItem('role', response.data.user.role)
        localStorage.setItem('username', response.data.user.name)
        localStorage.setItem('userid', response.data.user.id)
      }
    })
  }

  componentWillUnmount (){
  }

  render() {
    return (
      <div>
      <div className="modal-backdrop show" style={{display: this.state.created ? 'none' : 'block' }}></div>
        <Navigation role={this.state.role} name={this.state.name} />
      <div className="container">
        <div className="jumbotron mt-4">
          <div className="col-sm-4 mx-auto">
          <h1 className="text-center">Profile</h1>
          </div>
          <div className="col mt-4 mx-auto">
          <table className="table col md-4 mx-auto">
            <tbody>
              <tr>
                <td>Role</td>
                <td>{this.state.role}</td>
              </tr>
              <tr>
                <td>Name</td>
                <td>{this.state.name}</td>
              </tr>
              <tr>
                <td>Email</td>
                <td>{this.state.email}</td>
              </tr>
              <tr>
                <td>Created at</td>
                <td>{this.state.created}</td>
              </tr>
            </tbody>
          </table> 
          </div>
        </div>
      </div>
      </div>
    )
  }
}
