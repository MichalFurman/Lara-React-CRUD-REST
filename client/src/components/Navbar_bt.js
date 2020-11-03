import React, {Component} from 'react'
import {Link, withRouter} from 'react-router-dom'
import { Navbar,Nav,NavDropdown,Form,FormControl,Button } from 'react-bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css';

class Navigation extends Component {

  logOut(event) {
    event.preventDefault()
    localStorage.clear()
    this.props.history.replace('/login')
  }

  render() {

    const loginRegLink = (
      <Navbar.Collapse id="basic-navbar-nav">
        <Nav className="mr-auto">
        </Nav>
        <Nav>
          <Nav.Link href="/login">Login</Nav.Link>
        </Nav>
      </Navbar.Collapse>
    )

    const userLink = (
      <Navbar.Collapse id="basic-navbar-nav">
        <Nav className="mr-auto">
          <Nav.Item href="/">Home</Nav.Item>
          <Nav.Link href="/upload">Upload files</Nav.Link>
          </Nav>
          <Nav>
          <NavDropdown title={(typeof this.props.name !== 'undefined') ? this.props.name : localStorage.getItem('username')} id="basic-nav-dropdown">
            <NavDropdown.Item href="/profile">Profile</NavDropdown.Item>
            <NavDropdown.Item href="/updateprofile">Edit</NavDropdown.Item>
            <NavDropdown.Divider />
            <NavDropdown.Item href="/" onClick={this.logOut.bind(this)}>Logout</NavDropdown.Item>
          </NavDropdown>
        </Nav>
      </Navbar.Collapse>
    )

    const adminLink = (
      <Navbar.Collapse id="basic-navbar-nav">
        <Nav className="mr-auto">
          <Nav.Link href="/">Home</Nav.Link>
          <Nav.Link href="/upload">Upload files</Nav.Link>
          <Nav.Link href="/adduser">Add new user</Nav.Link>
          </Nav>
          <Nav>
          <NavDropdown title={(typeof this.props.name !== 'undefined') ? this.props.name : localStorage.getItem('username')} id="basic-nav-dropdown">
            <NavDropdown.Item href="/profile">Profile</NavDropdown.Item>
            <NavDropdown.Item href="/updateprofile">Edit</NavDropdown.Item>
            <NavDropdown.Divider />
            <NavDropdown.Item href="/" onClick={this.logOut.bind(this)}>Logout</NavDropdown.Item>
          </NavDropdown>
        </Nav>
      </Navbar.Collapse>
    )
    console.log(this.props)
    let activeLink = loginRegLink
      if (typeof this.props.role !== 'undefined' && this.props.role === 'user')  activeLink = userLink 
      if (typeof this.props.role !== 'undefined' && this.props.role === 'admin')  activeLink = adminLink 
      if (localStorage.getItem('role') === 'user')  activeLink = userLink 
      if (localStorage.getItem('role') === 'admin')  activeLink = adminLink 
      
      
    return (
      <div className="row">
        <div className="col-md-12">
          <Navbar bg="dark" variant="dark" expand="lg" sticky="top">
            <Navbar.Brand href="/">
              <img
                alt=""
                src=""
                width="30"
                height="30"
                className="d-inline-block align-top"
              /> {' '} Simple REST CRUD APP </Navbar.Brand>
            <Navbar.Toggle aria-controls="basic-navbar-nav" />
            {activeLink}
          </Navbar>
        </div>
      </div>
    )
  }
}

export default withRouter(Navigation)