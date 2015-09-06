VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "boxcutter/centos64-i386"

  config.vm.boot_timeout = 300

  config.vm.post_up_message = "Welcome to the TweetFind Server development environment.
    Use the command 'vagrant ssh' to access your server."

  config.vm.provider "virtualbox" do |vb|
    vb.gui = true
    vb.memory = "512"
    vb.customize ["modifyvm", :id, "--natnet1", "192.168.100/24"]
  end

  config.vm.network "private_network", ip: "192.168.100.4"

  config.vm.network :forwarded_port, guest: 80, host: 8888
  config.vm.network :forwarded_port, guest: 9200, host: 9200

  config.vm.provision :shell do |sh|
    sh.path = "bootstrap.sh"
    sh.args = "development"
  end

end