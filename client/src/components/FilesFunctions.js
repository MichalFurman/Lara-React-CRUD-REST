import axios from 'axios'
import {gui} from './gui'

export const uploadFile = data => {
  let url = "api/files";
  axios.post(url, data.data, { 
    headers: { Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret, 'Content-Type': 'multipart/form-data'}
  })
  .then(response => {
    if (response.data.token !== null && response.status === 200) return response
    return null
  })
  .catch((errors) => {
    if (errors.response) return errors.response
    return null
  })
}

export const itemsList = () => {
  return axios
  .get('api/files', {
      headers: { Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret, 'Content-Type': 'application/json' }
    })
    .then(response => {
      if (response.data.token !== null && response.status === 200) {
        if (response.data.files[0]['_id'] !== undefined){
          const files = response.data.files.map(({_id:id, ...rest}) => ({id:id, ...rest}))
          return files
        }
        return response.data.files
      }
      return null
    })
    .catch((errors) => {
      gui.modal('warning','Warning','Something is wrong. \nCheck errors: \n'+errors.response.data.message)
      if (errors.response) console.log(errors.response)
      return null
    })

}

export const deleteItem = params => {
  axios.delete(`/api/files/${params.id}`, {
    headers: { Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret, 'Content-Type': 'application/json' }
  })
  .then(response => {
    gui.modal_ah('success','Info','Delete successfully.')
    return response
  })
  .catch(errors => {
    gui.modal('warning','Warning','Something is wrong. \n Delete was canceled.\n\nCheck errors: \n'+errors.response.data.message)
    console.log(errors)
  })
}

export const updateItem = (id,name) => {
  return axios
  .put('/api/files/'+id, 
      { name: name }, 
      { headers: { Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret, 'Content-Type': 'application/json'} }
    )
    .then(response => {
      gui.modal_ah('success','Info','Update successfully.')
      return response
    })
    .catch(errors => {
      if (errors.response.data.message === 'empty_name') gui.modal('warning','Warning','Name can not be empty. \nUpdate was cancelled.')
      else gui.modal('warning','Warning','Something is wrong. \n Update was canceled.\n\nCheck errors: \n'+errors.response.data.message)
    })
}
