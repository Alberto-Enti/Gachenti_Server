#include<iostream>
#include<cstdlib>
#include<string>
#include<vector>

const std::string nextLine = "\n";

static class Color{
	const std::string RED = "\033[31m";
	const std::string GREEN = "\033[32m";
	const std::string YELLOW = "\033[33m";
	const std::string BLUE = "\033[34m";
	const std::string PURPLE = "\033[35m";
	const std::string CYAN = "\033[36m";
	const std::string GRAY = "\033[37m";
}

class Menu{
public:
	std::string title;
	std::vector<std::string> option;

	void showOptions(){
		std::cout << title << nextLine;
		for(int i = 0; i < option.size(); i++){
			std::cout<<"	"<<i<<" - "<<option[i]<<nextLine;
		}
	}
};


void InitializeMainMenu(Menu& mainMenu){
mainMenu.title = "Gachenti Database Manager";
mainMenu.option.push_back("Init Database");
mainMenu.option.push_back("Drop Database");
}

int main(){
Menu mainMenu;
std::vector<Menu> menus;
InitializeMainMenu(mainMenu);
mainMenu.showOptions();
return 0;

}

