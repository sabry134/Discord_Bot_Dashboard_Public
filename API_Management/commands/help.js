let isHelpCommandEnabled = true;

module.exports = (msg) => {
  if (msg.content === "!help" && isHelpCommandEnabled) {
    msg.reply("Here is a list of commands you can use :\n--help\n to have a list of the commands available\n ping, /chooseHouse");
  }
};

module.exports.setHelpCommandStatus = (status) => {
  isHelpCommandEnabled = status;
};
