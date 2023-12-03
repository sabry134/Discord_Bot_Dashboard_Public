folder ('Tools') {
  description('Folder for miscellaneous tools.')
}

job ('Tools/clone-repository'){
  wrappers {
    preBuildCleanup {}
  }
  description('Git URL of the repository to clone')
  parameters {
    stringParam('GIT_REPOSITORY_URL', '', 'Git URL of the repository to clone')
  }
  steps {
    shell("git clone \$GIT_REPOSITORY_URL")
  }
}

job ('Tools/SEED'){
  parameters {
    stringParam('GITHUB_NAME', '', 'GitHub repository owner/repo_name (e.g.: "EpitechIT31000/chocolatine")')
    stringParam('DISPLAY_NAME', '', 'Display name for the job')
  }
  steps {
    dsl {
      text('job(\'Tools/DISPLAY_NAME\'){\n' +
        '\twrappers {\n' +
        '\t\tpreBuildCleanup {}\n' +
        '\t}\n' +
        '\tscm {\n' +
        '\t\tgithub("\$GITHUB_NAME")\n' +
        '\t}\n' +
        '\ttriggers {\n' +
        '\t\tscm("H/1 * * * *")\n' +
        '\t}\n' +
        '\tsteps {\n' +
        '\t\tshell("make fclean")\n' +
        '\t\tshell("make")\n' +
        '\t\tshell("make test")\n' +
        '\t\tshell("make clean")\n' +
        '\t}\n' +
        '}')
    }
  }
}