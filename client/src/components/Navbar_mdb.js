import React, {Component} from 'react'
import {Link, withRouter} from 'react-router-dom'
// import { Navbar,Nav,NavDropdown,Form,FormControl,Button } from 'react-bootstrap'
// import 'bootstrap/dist/css/bootstrap.min.css';
import { MDBNavbar, MDBNavbarBrand, MDBNavbarNav, MDBNavItem, MDBNavLink, MDBNavbarToggler, MDBCollapse, MDBDropdown,
  MDBDropdownToggle, MDBDropdownMenu, MDBDropdownItem, MDBContainer, MDBIcon } from "mdbreact";
import 'mdbreact/dist/css/mdb.css';
import './fa4/css/font-awesome.min.css';

class Navigation extends Component {

  state = {
    collapseID: ""
  };
  
  toggleCollapse = collapseID => () =>
    this.setState(prevState => ({
    collapseID: prevState.collapseID !== collapseID ? collapseID : ""
  }));
  
  logOut(event) {
    event.preventDefault()
    localStorage.clear()
    this.props.history.replace('/login')
  }

  render() {

    const loginRegLink = (
      <MDBCollapse id="navbarCollapse3" isOpen={this.state.collapseID} navbar>
      <MDBNavbarNav right>
        <MDBNavItem>
          <MDBNavLink className="waves-effect waves-light" to="/login">
          <MDBIcon icon="angle-up" className="mr-1"/>Login</MDBNavLink>
        </MDBNavItem>
      </MDBNavbarNav>
      </MDBCollapse>
    )

    const userLink = (
      <MDBCollapse id="navbarCollapse3" isOpen={this.state.collapseID} navbar>
      <MDBNavbarNav left>
        <MDBNavItem>
          <MDBNavLink className="waves-effect waves-light" to="/">
          <MDBIcon fab icon="acquisitions-incorporated" />Home</MDBNavLink>
        </MDBNavItem>
        <MDBNavItem>
          <MDBNavLink className="waves-effect waves-light" to="/upload">
            <MDBIcon fav icon="envelope" className="mr-1"/>Upload files</MDBNavLink>
        </MDBNavItem>
        </MDBNavbarNav>
        <MDBNavbarNav right>
        <MDBNavItem>
          <MDBDropdown>
            <MDBDropdownToggle nav caret>
              <MDBIcon icon="user" className="mr-1" />{(typeof this.props.name !== 'undefined') ? this.props.name : localStorage.getItem('username')}
            </MDBDropdownToggle>
            <MDBDropdownMenu className="dropdown-default" right>
              <MDBDropdownItem href="/profile">Profile</MDBDropdownItem>
              <MDBDropdownItem href="updateprofile">Edit</MDBDropdownItem>
              <MDBDropdownItem href="/" onClick={this.logOut.bind(this)}>Log out</MDBDropdownItem>
            </MDBDropdownMenu>
          </MDBDropdown>
        </MDBNavItem>
      </MDBNavbarNav>
      </MDBCollapse>
    )

    const adminLink = (
      <MDBCollapse id="navbarCollapse3" isOpen={this.state.collapseID} navbar>
      <MDBNavbarNav left>
        <MDBNavItem>
          <MDBNavLink className="waves-effect waves-light" to="/">
          <MDBIcon icon="home"  className="mr-1"/>Home</MDBNavLink>
        </MDBNavItem>
        <MDBNavItem>
          <MDBNavLink className="waves-effect waves-light" to="/upload">
          <MDBIcon icon="upload" className="mr-1"/>Upload files</MDBNavLink>
        </MDBNavItem>
        <MDBNavItem>
          <MDBNavLink className="waves-effect waves-light" to="/adduser">
            <MDBIcon icon="user-plus" className="mr-1" />Add new user</MDBNavLink>
        </MDBNavItem>
        </MDBNavbarNav>
        <MDBNavbarNav right>
        <MDBNavItem>
          <MDBDropdown>
            <MDBDropdownToggle nav caret>
            <MDBIcon icon="user-circle" className="mr-1" /> {(typeof this.props.name !== 'undefined') ? this.props.name : localStorage.getItem('username')}
            </MDBDropdownToggle>
            <MDBDropdownMenu className="dropdown-default" right>
              <MDBDropdownItem href="/profile"><MDBIcon icon="user-circle" className="mr-1" />Profile</MDBDropdownItem>
              <MDBDropdownItem href="updateprofile"><MDBIcon icon="edit" className="mr-1" />Edit</MDBDropdownItem>
              <MDBDropdownItem href="/" onClick={this.logOut.bind(this)}><MDBIcon icon="eject" className="mr-1" />Log out</MDBDropdownItem>
            </MDBDropdownMenu>
          </MDBDropdown>
        </MDBNavItem>
      </MDBNavbarNav>
      </MDBCollapse>
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
        <MDBContainer>
          <MDBNavbar color="unique-color" dark expand="md" style={{ marginTop: "20px"}}>
            <MDBNavbarBrand  href="/login">
            <strong >Simple REST CRUD APP</strong>
            </MDBNavbarBrand>
            <MDBNavbarToggler onClick={this.toggleCollapse("navbarCollapse3")} />
            {activeLink}
          </MDBNavbar>
        </MDBContainer>
        </div>
      </div>
    )
  }
}

export default withRouter(Navigation)