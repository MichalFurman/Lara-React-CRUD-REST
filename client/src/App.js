import React, {Component} from 'react'
import {BrowserRouter as Router, Route, Switch} from 'react-router-dom'


import Landing from './components/Landing'
import Login from './components/Login'
import Profile from './components/Profile'
import EditProfile from './components/ProfileEdit'
import Register from './components/Register'
import AddUser from './components/AddUser'
import Upload from './components/Upload'

import notFound from './components/notFound'


class App extends Component {
  render() {
    return (
      <Router>
        <div className="App">
          <Switch>
            <Route exact path="/" component={Landing}/>
            <Route exact path="/register" component={Register}/>
            <Route exact path="/login" component={Login}/>
            <Route exact path="/upload" component={Upload}/>
            <Route exact path="/profile" component={Profile}/>
            <Route exact path="/updateprofile" component={EditProfile}/>
            <Route exact path="/adduser" component={AddUser}/>
            <Route component={notFound}/>
          </Switch>
        </div>
      </Router>
    )
  }
}

export default App;
