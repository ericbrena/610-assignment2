<?php

class ConstNames {
	const url = "http://eb223fz.000webhostapp.com";

	const isLoggedIn = "Session::IsLoggedIn";
	
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

	//gameview
	const newGame = "Game::NewGame";
	const gameActive = "Game::ActiveGame";
	const gameBoard = "Game::GameInfo";
	const gameMoveUp = "Game::MoveUp";
	const gameMoveRight = "Game::MoveRight";
	const gameMoveDown = "Game::MoveDown";
	const gameMoveLeft = "Game::MoveLeft";

	//css
	const buttonWrapper = "ButtonWrapper";
	const upperButton = "UpperButton";
	const lowerButtons = "LowerButtons";

	//pages
	const registerURL = "/?register";

}