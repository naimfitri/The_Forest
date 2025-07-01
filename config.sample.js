// Sample configuration file - copy this to config.js and add your actual API keys
const config = {
  maptilerApiKey: 'YOUR_MAPTILER_API_KEY_HERE'
};

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
  module.exports = config;
} else {
  window.config = config;
}
