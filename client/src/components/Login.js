import React, {Component} from 'react'
import {login} from './UserFunctions'
import Navigation from './Navbar'
import {gui} from './gui'


export default class Login extends Component {

  constructor() {
    super()
    this.state = {
      email: '',
      password: '',
      errors: {}
    }

    this.onChange = this.onChange.bind(this)
    this.onSubmit = this.onSubmit.bind(this)

  }

  componentDidMount(){
    if (localStorage.userToken && localStorage.role !== '') this.props.history.push('/')
  }

  onChange(event) {
    this.setState({[event.target.name]: event.target.value})
  }

  onSubmit(event) {
    event.preventDefault()
    const user = {
      email: this.state.email,
      password: this.state.password
    }

    login(user).then(response => {
      if (response && response.status === 200) {
        gui.modal_ah('success','Info',"Welcome. You are logged succefully.")
        this.props.history.replace('/profile')
      }
      else {
        if (response.data.message === 'invalid_credentials')
          gui.modal('info','Info','Invalid credentials.')
        else if (response.data.message === 'could_not_create_token')
          gui.modal('danger','Warning','Could not create user token.')
        else gui.modal('danger','Warning','Something is wrong.\n Perhaps server is not responding.\n\nCheck errors:\n'+response.data.message)
          this.setState({
            email:'',
            password:''
          })    
      }
    })
  }

  render() {
    return (
      <div>
        <Navigation/>
      <div className="container">
      <div className="jumbotron mt-4">
        <div className="row">
          <div className="col-md-6 mx-auto">
            <form noValidate onSubmit={this.onSubmit}>
              <h1 className="text-center">
                Please login
              </h1>
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
              <button type="submit" className="btn btn-lg btn-primary btn-block">Sign In</button>
            </form>
          </div>
        </div>
      </div>
      </div>
      </div>
    )
  }
}