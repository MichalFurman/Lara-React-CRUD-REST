import React, {Component} from 'react'
import {checkUser} from './UserFunctions'
import {storeNewUser} from './UserFunctions'
import Navigation from './Navbar'
import {gui} from './gui'

export default class AddUser extends Component {

  constructor() {
    super()
    this.state = {
      first_name: '',
      last_name: '',
      email: '',
      password: '',
      role:'user',
      errors: {}
    }

    this.onChange = this.onChange.bind(this)
    this.onSubmit = this.onSubmit.bind(this)

  }

  componentDidMount(){
    checkUser(this.props, ['admin'])
  }

  onChange(event) {
    this.setState({[event.target.name]: event.target.value})
    console.log(event.target.name+' '+event.target.value)
  }

  onSubmit(event) {
    event.preventDefault()
    const newUser = {
      name: this.state.first_name+' '+this.state.last_name,
      email: this.state.email,
      password: this.state.password,
      role: this.state.role
    }
    storeNewUser(newUser, this.props)
  }

  render() {
    // if (!localStorage.userToken || localStorage.role !== 'admin') this.props.history.push('/login')
    return (
      <div>
      <div className="modal-backdrop show" style={{display: this.state ? 'none' : 'block' }}></div>
        <Navigation/>
      <div className="container">
      <div className="jumbotron mt-4">
        <div className="row">
          <div className="col-md-6 mx-auto">
            <form noValidate onSubmit={this.onSubmit}>
              <h1 className="text-center">
                Create new user/admin
              </h1>
              <div className="form-group">
                <label htmlFor="first_name">Role</label>
                <select className="form-control" name="role" onChange={this.onChange}>
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <div className="form-group">
                <label htmlFor="email">Email Address</label>
                <input 
                type="email" 
                className="form-control"
                name="email"
                placeholder="Email address"
                value={this.state.email}
                onChange={this.onChange}/>
              </div>
              <div className="form-group">
                <label htmlFor="first_name">First name</label>
                <input 
                type="text" 
                className="form-control"
                name="first_name"
                placeholder="enter first name"
                value={this.state.first_name}
                onChange={this.onChange}/>
              </div>
              <div className="form-group">
                <label htmlFor="last_name">Last name</label>
                <input 
                type="text" 
                className="form-control"
                name="last_name"
                placeholder="enter last name"
                value={this.state.last_name}
                onChange={this.onChange}/>
              </div>
              <div className="form-group">
                <label htmlFor="password">Password</label>
                <input 
                type="password" 
                className="form-control"
                name="password"
                placeholder="Enter password"
                value={this.state.password}
                onChange={this.onChange}/>
              </div>
              <button type="submit" className="btn btn-lg btn-primary btn-block">Create</button>
            </form>
          </div>
        </div>
      </div>
      </div>
      </div>
    )
  }
}
