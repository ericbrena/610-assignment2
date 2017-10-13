<?php

class ConstNames {
	const url = "http://localhost:8080";

	const LoggedIn = "Session::IsLoggedIn";
	
	//file paths
	const databaseFile = "model/database.txt";
	const gameEditorFile = "model/GameEditor.css";

    //loginview
    const login = "LoginView::Login";
	const logout = "LoginView::Logout";
	const name = "LoginView::UserName";
	const savedName = "LoginView::SavedUserName";
	const password = "LoginView::Password";
	const keep = "LoginView::KeepMeLoggedIn";
	const messageId = "LoginView::Message";

    //registerview
	const registerName = "RegisterView::UserName";
	const savedRegisteredName = "RegisterView::SavedUserName";
	const registerPassword = "RegisterView::Password";
	const registerPasswordRepeat = "RegisterView::PasswordRepeat";
	const register = "RegisterView::Register";
	const registerMessageId = "RegisterView::Message";

	const newGame = "Game::NewGame";
	const gameActive = "Game::ActiveGame";
	const gameBoard = "Game::GameInfo";

	//pages
	const registerURL = "/?register";

}