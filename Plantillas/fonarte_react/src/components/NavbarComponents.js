import React, { Component} from 'react';
import {Navbar,Nav,NavDropdown,Container,Offcanvas,Form,FormControl,Button} from 'react-bootstrap';
import logo from '../assets/img/logo.png'

export default class NavBarComponents extends Component {
  render() {
    return (
      <div>
        <Navbar bg="dark" variant="dark" expand="lg">
        <Container>
            <Navbar.Brand href="#home"><img class='responsive' style={{height:'auto',width:'100%'}} src={ logo }/></Navbar.Brand>
            <Navbar.Toggle aria-controls="basic-navbar-nav" />
            <Navbar.Collapse id="basic-navbar-nav">
            <Nav className="me-auto">
                <Nav.Link href="#home">Home</Nav.Link>
                <Nav.Link href="#link">FonarteLatino</Nav.Link>
                <NavDropdown title="Catálogo" id="basic-nav-dropdown">
                    <NavDropdown.Item href="#action/3.1">Colecciones</NavDropdown.Item>
                    <NavDropdown.Item href="#action/3.2">Discos/DVD</NavDropdown.Item>
                    <NavDropdown.Item href="#action/3.3">Vinil</NavDropdown.Item>
                </NavDropdown>
                <Nav.Link href="#link">Contacto</Nav.Link>
            </Nav>
            </Navbar.Collapse>
        </Container>
        </Navbar>
        
        
      </div>
    )
  }
}
