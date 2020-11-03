import axios from 'axios'
import {gui} from './gui'

export const register = newUser => {
  return axios
  .post('api/register', newUser, {
      headers: {'Content-Type': 'application/json'}
    })
    .then(resources => {
      console.log(resources)
    })
    .catch(err => console.log(err))
}

export const storeNewUser = (newUser, props) => {
  return axios
  .post('api/adduser', newUser, {
      headers: {Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret, 'Content-Type': 'application/json'}
    })
    .then(response => {
      if (response.status === 201) {
        gui.modal('success','Info',"New User added successfully.")
        props.history.push('/')
      }
      else gui.modal('warning','Info',"Something is wrong.")
    })
    .catch(errors => {
      console.log(errors.response)
      gui.modal('warning','Info',"Something is wrong.\n\nCheck errors:\n"+errors.response.data.message)
    })
}

export const login = user => {
  return axios
  .post('api/login', 
    {
      email: user.email,
      password: user.password
    }, 
    { 
      headers: {Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret, 'Content-Type': 'application/json'}
    }
  )
  .then(response => {
    console.log(response)
    if (response.data.token !== null && response.status === 200) {
      localStorage.setItem('userToken', response.data.token)
      localStorage.setItem('secret', response.data.secret)
      return response
    }
    return null
  })
  .catch((errors) => {
    console.log(errors.response)
    return errors.response
  })
}

export const logOut = () => {
  // event.preventDefault()
  return axios
  .get('api/logout', {
      headers: { Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret},
    })
    .then(response => {
      console.log(response)
      if (response.data.token !== null && response.status === 200) {
        // localStorage.clear()
        // gui.modal_ah('success','Info',"You are logged out succefully.")
        // this.props.history.replace('/login')
      }
      return null
    })
    .catch((errors) => {
      if (errors.response) console.log(errors.response)
      return null
    })
}


export const getProfile = () => {
  return axios
  .get('api/profile', {
      headers: { Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret},
    })
    .then(response => {
      console.log(response)
      if (response.data.token !== null && response.status === 200) return response
      return null
    })
    .catch((errors) => {
      if (errors.response) console.log(errors.response)
      return null
    })
}

export const updateProfile = (user, props) => {
  return axios
  .put('api/updateprofile', user, {
      headers: {Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret, 'Content-Type': 'application/json'}
    })
    .then(response => {
      if (response.status === 200) {
        console.log(response)
        if (response.data.message === 'credentials_changed'){
          gui.modal('success','Info',"Profile with credentials updated successfully.\nPlease login again.")
          localStorage.clear()
          props.history.replace('/login')      
        } 
        else {
          gui.modal('success','Info',"Profile updated successfully.")
          localStorage.setItem('username',user.name)
          props.history.push('/profile')      
        }
      }
      else gui.modal('warning','Info',"Something is wrong.")
    })
    .catch(errors => {
      console.log(errors.response)
      gui.modal('warning','Info',"Something is wrong.\n\nCheck errors:\n"+errors.response.data.message)
    })
}

export const checkUser = (props, role_tab = ['user']) => {
  return axios
  .get('api/checkuser', {
      headers: { Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret},
    })
    .then(response => {
      if (response.data.token !== null && response.status === 200) {
        let permission = 0
        Object.keys(role_tab).forEach(key => {
          if (role_tab[key] === 'all') permission += 1
          if (role_tab[key] === response.data.user.role) permission += 1
        })
        if (permission === 0) {
          gui.modal('warning','Info',"You don't have permissions for this operation.")          
          props.history.push('/')
        }
      }
      
      else {
        gui.modal('warning','Info','Something is wrong.\n Perhaps You are logged out.')
        localStorage.clear()
        props.history.push('/login')
      }
    })
    .catch((errors) => {
      if (errors.response) {
        gui.modal('warning','Info','Something is wrong.\n Perhaps You are logged out.')
        localStorage.clear()
        props.history.push('/login')
      }
    })
}
