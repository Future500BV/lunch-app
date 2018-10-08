# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

    config.vm.define "lunch_app_develop", primary: true do |config_develop|
        config_develop.vm.box = "f500/debian-stretch64"

        config_develop.vm.hostname = "lunchapp.loc"

        config_develop.vm.network :private_network, ip: "192.168.100.100"

        config_develop.vm.synced_folder ".", "/vagrant", nfs: true

        config_develop.vm.provider :virtualbox do |vb|
            vb.name = "lunch_app_develop"
            vb.cpus = "1"
            vb.memory = "1024"
            vb.gui = false

            vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
            vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
        end

        config_develop.vm.provision :ansible do |ansible|
            ansible.compatibility_mode = "2.0"
            ansible.inventory_path = "ansible/hosts"
            ansible.playbook = "ansible/provision/playbook.yml"
            ansible.limit = "develop"
        end
    end
end
