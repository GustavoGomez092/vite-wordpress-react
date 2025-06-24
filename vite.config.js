import { defineConfig } from 'vite';
import path, { resolve } from 'path';
import react from '@vitejs/plugin-react-swc';

export default defineConfig(({ mode }) => {
  const isProduction = mode === 'production';

  return {
    resolve: {
      alias: [{ find: '@', replacement: path.resolve(__dirname, 'src') }],
    },
    build: {
      lib: {
        entry: resolve(__dirname, 'src/main.jsx'),
        name: 'react-wp',
        fileName: 'react-wp',
      },
      sourcemap: !isProduction, 
      minify: isProduction, 
    },
    define: {
      'process.env.NODE_ENV': JSON.stringify(mode),
    },
    plugins: [react()],
    server: {
      port: 5173,
    },
  };
});
