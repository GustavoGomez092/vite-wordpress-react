# React + Vite WordPress Plugin Boilerplate

This template provides a minimal setup to get React working in Vite with HMR and some ESLint rules as a WordPress plugin.

To start your project:<br/>
```git clone https://github.com/GustavoGomez092/vite-wordpress-react.git```

Change directory into the project folder:<br/>
```cd react-wp```

Install dependencies:<br/>
```npm install```

Before starting development:<br/>
```npm run init```

Development server:<br/>
```npm run dev```

Package to zip:<br/>
```npm run package {{zipName}}```


## Considerations

To avoid style conflicts with any WordPress theme that you are using for your site, the plugin by default comes with a: "tw-" prefix on all classes (this can be disabled through the <code>tailwind.config.js</code>). We also added <code>scopedPreflightStyles</code> to limit Tailwind's CSS style resets to only happen at plugin container level.
