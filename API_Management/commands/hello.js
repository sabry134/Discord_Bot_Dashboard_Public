let isHelloCommandEnabled = true;

module.exports = (msg) => {
  if (msg.content === "!hello" && isHelloCommandEnabled) {
    msg.reply("Hello world!");
  }
};

module.exports.setHelloCommandStatus = (status) => {
  isHelloCommandEnabled = status;
};
