import React, {Component} from 'react'
import {checkUser} from './UserFunctions'
import {getProfile,updateProfile} from './UserFunctions'
import Navigation from './Navbar'

export default class EditProfile extends Component {

  constructor() {
    super()
    this.state = {
      first_name: '',
      last_name: '',
      email: '',
      password: '',
      role:'',
      errors: {}
    }

    this.onChange = this.onChange.bind(this)
    this.onSubmit = this.onSubmit.bind(this)

  }

  componentDidMount(){
    checkUser(this.props, ['all'])
    getProfile().then(
      response =>{
        if (response) {
          let name = response.data.user.name.split(" ")
          this.setState({
            first_name: name[0],
            last_name: name[1],
            email: response.data.user.email,
            role: 'old',
            created: response.data.user.created_at
          })
          localStorage.setItem('role', response.data.user.role)
        }
      })

  }

  onChange(event) {
    this.setState({[event.target.name]: event.target.value})
    console.log(event.target.name+' '+event.target.value)
  }

  onSubmit(event) {
    event.preventDefault()
    const user = {
      name: this.state.first_name+' '+this.state.last_name,
      email: this.state.email,
      password: this.state.password,
      role: this.state.role
    }
    updateProfile(user, this.props)
  }

  render() {
    return (
      <div>
      <div className="modal-backdrop show" style={{display: this.state.created ? 'none' : 'block' }}></div>
        <Navigation/>
      <div className="container">
      <div className="jumbotron mt-4">
        <div className="row">
          <div className="col-md-6 mx-auto">
            <form noValidate onSubmit={this.onSubmit}>
              <h1 className="text-center">
                Edit profile
              </h1>
              <div className="form-group">
                <label htmlFor="first_name">Role</label>
                <select className="form-control" name="role" onChange={this.onChange}>
                  <option value="old">no change</option>
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
                placeholder="enter email address"
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
              <button type="submit" className="btn btn-lg btn-success btn-block" disabled={!this.state.created}>Save</button>
            </form>
          </div>
        </div>
      </div>
      </div>
      </div>
    )
  }
}
