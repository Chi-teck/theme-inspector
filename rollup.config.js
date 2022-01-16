import {nodeResolve} from "@rollup/plugin-node-resolve"

export default {
    input: 'js/src/index.js',
    output: {
        file: 'js/dist/theme-inspector.js',
        format: 'iife',
    },
    plugins: [
        nodeResolve(),
    ]
};
