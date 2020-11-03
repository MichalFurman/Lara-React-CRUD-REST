import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap4-dialog/dist/css/bootstrap-dialog.min.css';
import React, {Component} from 'react'
import axios from 'axios'
import {checkUser} from './UserFunctions'
import {itemsList, updateItem, deleteItem} from './FilesFunctions'
import Navigation from './Navbar'
import {gui} from './gui'
import $ from 'jquery';


export default class FileUpload extends Component {

  constructor(){
    super();
    this.state = {
      selectedFile:'',
      filesList: [],
      filesListStatus: 'Please wait, loading list...',
      editDisabled: false,
      editItem: [],
    }
    this.handleInputChange = this.handleInputChange.bind(this);
  }

  componentDidMount(){
    checkUser(this.props, ['all'])
    this.getFiles()
  }

  getFiles = (id='all') => {
    this.setState({
      filesList: [],
      filesListStatus: 'Please wait, loading list...'
    })
    itemsList().then(data =>{
      let files = []
      if (id !== 'all' && Array.isArray(data) && data.length) {
         files = data.filter((elem) => {if (elem.user_id == id) return elem})
      }
      else files = data;
      
      if (Array.isArray(files) && files.length > 0)       
      this.setState({
        filesList: [...files],
        filesListStatus: ''
      })
      else 
      this.setState({
        filesList: [],
        filesListStatus: 'No files in list.'
      })
    })
  }

  imgModal = (name, path) => {
    gui.modal('info', name, '<center><img src="'+path+'"></center>')
  }

  editModal = (name, params) => {
    gui.modal_confirm('warning', name, '<center>Are you sure you want to edit item "'+name+'"?</center>', this.onEdit, params)
  }

  onUpdate = (id) => {
    updateItem(id, this.state.editItem.name)
    this.getFiles()
  }

  deleteModal = (name, params) => {
    gui.modal_confirm('danger', 'Delete', '<center>Are you sure you want to delete item "'+name+'"?</center>', this.onDelete, params)
  }

  onDelete = (params) => {
    deleteItem(params)
    this.getFiles()
  }


  handleInputChange(event) {
    this.setState({
      selectedFile: event.target.files[0],
    })
  }

  onChange(event) {
    this.setState({[event.target.name]: event.target.value})
    console.log(event.target.name+': '+event.target.value)
  }


  submit(){
    const data = new FormData() 
    data.append('file', this.state.selectedFile)
    console.log(data)
    let url = "api/files";
    axios.post(url, data, { 
      headers: { Authorization : `Bearer ${localStorage.userToken}`, Secret: localStorage.secret, 'Content-Type': 'multipart/form-data'}
    })
    .then(response => {
      if (response.data.message === 'upload_success')
        gui.modal_ah('success','Info','Upload successfully.')
        this.getFiles()
    })
    .catch((errors) => {
      console.log(errors.response)
      if (errors.response.data.message === 'empty_file') gui.modal('warning','Warning','No file selected or file is empty.')
      else gui.modal('warning','Warning','Something is wrong. \n Upload was canceled.\n\nCheck errors: \n'+errors.response.data.message)
      this.getFiles()
    })
    $('#file').val('')
    this.setState({
      selectedFile: ''
    })
  }

 
  render() {
    return (
      <div>
        <Navigation/>
      <div className="container">
        <div className="jumbotron mt-4">
        <div className="row-12">
          <h1 className="text-center">Files in list</h1>
        </div>
        <div className="btn-group col-12">
          <div className="col-4">
            <input type="file" id="file" name="file" onChange={this.handleInputChange}/>
            <button type="submit" className="btn btn-sm btn-primary btn-block"  onClick={()=>this.submit()}>Upload</button>
          </div>
          <div className="col-3 offset-6">
            <div
              className="btn btn-sm btn-success"
              data-toggle="modal" 
              style={{cursor: 'pointer', margin: '10px'}}
              title="show all files"
              onClick={() => {this.getFiles()}}>
                All </div>
            <div
              className="btn btn-sm btn-info"
              data-toggle="modal" 
              style={{cursor: 'pointer', margin: '10px'}}
              title="show only my files"
              onClick={() => {this.getFiles(localStorage.getItem('userid'))}}>
                My </div>
          </div>
        </div>
        <div>
          <br/>
          <table className="table">
            <tbody>
              {
              this.state.filesList.map((file, index) => (
                <tr key={index}>
                <td className="text-left col-8" title="click to enlarge"><a className="imgLink" onClick={() => {this.imgModal(file.name, file.path)}}>{file.name}</a></td>
                <td className="text-left col-3" title="owner">{file.user_name}</td>
                <td className="text-left col-1">
                  <div className="btn-group">
                    <div
                      // className="btn btn-sm btn-primary"
                      data-toggle="modal" 
                      style={{cursor: 'pointer', margin: '10px'}}
                      title="show file"
                      onClick={() => {this.imgModal(file.name, file.path)}}>
                        <i class="fa fa-picture-o"></i></div>
                    <div
                      href="#"
                      style={{cursor: 'pointer', margin: '10px', display: file.user_id != localStorage.getItem('userid') ? 'none' : 'block' }}
                      data-toggle="modal"
                      data-target={'#'+index}
                      title="edit file name"
                      onClick={()=>{this.setState({editItem: {name: file.name}})}}> 
                        <i class="fa fa-pencil"></i></div>
                    <div
                      href="#"
                      style={{cursor: 'pointer', margin: '10px', display: file.user_id != localStorage.getItem('userid') ? 'none' : 'block' }}
                      title="delete file"
                      onClick={() => {this.deleteModal(file.name, file)}}>
                        <i class="fa fa-trash-o"></i></div>                                 
                  </div>
                  <div className="modal fade" id={index} role="dialog">
                    <div className="modal-dialog modal-lg">
                      <div className="modal-content">
                        <div className="modal-header bg-warning">
                          Edit name for: "{file.name}"
                          <button type="button" className="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div className="modal-body">
                          <input type="text" className="form-control" name="editname" placeholder="enter new name" value={this.state.editItem.name} onChange={(event) => { this.setState({editItem:{name: event.target.value}})}} required /> 
                        </div>
                        <div className="modal-footer">
                          <button type="button" className="btn btn-success" data-dismiss="modal" onClick={() =>{this.onUpdate(file.id)}}  disabled={!this.state.editItem.name}>Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>                
              </tr>
            ))}
            <tr><td colSpan="3" align="center">{this.state.filesListStatus}</td></tr>
          </tbody>
        </table>
       </div>
      </div>
      </div>
      </div>
    )
  }
}