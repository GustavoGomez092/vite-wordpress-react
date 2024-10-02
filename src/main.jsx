// add the beginning of your app entry
import React from 'react'
import 'vite/modulepreload-polyfill'
import ReactDOM from 'react-dom/client'
import App from './App.jsx'
import AppBackEnd from './AppBackEnd.jsx'
import './index.css'


if(document.getElementById('vitereact')) {
  ReactDOM.createRoot(document.getElementById('vitereact')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
  )
} else if(document.getElementById('vitereact-options')) {
  ReactDOM.createRoot(document.getElementById('vitereact-options')).render(
  <React.StrictMode>
    <AppBackEnd />
  </React.StrictMode>
  )
}
