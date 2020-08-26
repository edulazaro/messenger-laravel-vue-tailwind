module.exports = {
  purge: [],
  theme: {
    extend: {},
  },
  variants: {
    backgroundColor: ['responsive', 'group-hover', 'first', 'last', 'odd', 'even', 'hover', 'focus', 'active', 'visited', 'disabled']
  },
  plugins: [
    require('@tailwindcss/ui'),
  ]
}
