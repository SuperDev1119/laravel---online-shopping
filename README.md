## Run the App

1. Clone this repository
2. Copy `.env.example` into `.env`
3. Edit `/etc/hosts` and add the following line: `192.168.56.56   modalova.test`
4. Install Virtual Box on your machine. (VirtualBox)[https://www.virtualbox.org/wiki/Downloads]
5. Install Vagrant on your machine. (Vagrant)[https://www.vagrantup.com/downloads]
6. Run `cd vagrant` when inside the repository and then `vagrant up` in terminal
7. Open `modalova.test` in your browser to run the app

## Working inside homestead
- To use homestead, make sure you are inside the vagrant directory.
- Make sure vagrant machine is running. This could be checked via `vagrant status`
- If the box is running. Run `vagrant ssh`
- Once inside Homestead, run `cd code`
- From here onwards, you can run all php artisan, postgres and npm commands
- To reload vagrant machine, run `vagrant reload --provision`
- To remove vagrant box, run `vagrant destroy`
- All these commands must be run from inside the vagrant directory in the repository