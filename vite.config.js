import { defineConfig } from 'vite'
import path, { resolve } from 'path'
import react from '@vitejs/plugin-react-swc'


let UrlArray
if (process.platform === 'win32') {
  UrlArray = __dirname.split('\\')
} else {
  UrlArray = __dirname.split('/')
}
const finalPath = UrlArray.slice(Math.max(UrlArray.length - 3, 0)).join('/')

export default defineConfig(({ mode }) => {
  if (mode === 'development') {
    return {
      base: `/${finalPath}/`,
      resolve: {
        alias: [
          { find: '@', replacement: path.resolve(__dirname, 'src') }
        ]
      },
      build: {
        lib: {
          // Could also be a dictionary or array of multiple entry points
          entry: resolve(__dirname, 'src/main.jsx'),
          name: 'react-wp',
          // the proper extensions will be added
          fileName: 'react-wp',
        },
      },
      define: {
        'process.env': {}
      },
      plugins: [react()],
      server: {
        port: 5173
      },
      rollupOptions: {
        // overwrite default .html entry
        input: './src/main.jsx',
      },
    }
  }
  if (mode === 'production') {
    return {
      base: `/${finalPath}/dist`,
      resolve: {
        alias: [
          { find: '@', replacement: path.resolve(__dirname, 'src') }
        ]
      },
      build: {
        lib: {
          // Could also be a dictionary or array of multiple entry points
          entry: resolve(__dirname, 'src/main.jsx'),
          name: 'react-wp',
          // the proper extensions will be added
          fileName: 'react-wp',
        },
      },
      define: {
        'process.env': {}
      },
      plugins: [react()],
      server: {
        port: 5173
      },
      rollupOptions: {
        // overwrite default .html entry
        input: './src/main.jsx',
      },
    }
  }
})