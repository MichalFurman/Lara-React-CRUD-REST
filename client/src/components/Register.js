import React, {Component} from 'react'
import {register} from './UserFunctions'
import Navigation from './Navbar'

export default class Register extends Component {

  constructor() {
    super()
    this.state = {
      first_name: '',
      last_name: '',
      email: '',
      password: '',
      errors: {}
    }

    this.onChange = this.onChange.bind(this)
    this.onSubmit = this.onSubmit.bind(this)

  }

  onChange(event) {
    this.setState({[event.target.name]: event.target.value})
  }

  onSubmit(event) {
    event.preventDefault()
    const newUser = {
      name: this.state.first_name+' '+this.state.last_name,
      email: this.state.email,
      password: this.state.password,
    }

    register(newUser).then((response) => {
      this.props.history.push('/')
    })
  }

  render() {
    return (
      <div>
        <Navigation/>
      <div className="container">
        <div className="row">
          <div className="col-md-6 mt-5 mx-auto">
            <form noValidate onSubmit={this.onSubmit}>
              <h1 className="h3 mb-3 font-weight-normal">
                Register new user
              </h1>
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
                <label htmlFor="password">Password</label>
                <input 
                type="password" 
                className="form-control"
                name="password"
                placeholder="Enter password"
                value={this.state.password}
                onChange={this.onChange}/>
              </div>
              <button type="submit" className="btn btn-lg btn-primary btn-block">Register</button>
            </form>
          </div>
        </div>
      </div>
      </div>
    )
  }
}
