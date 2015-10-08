<?php

use Laracasts\Behat\Context\DatabaseTransactions;

class AuthenticationContext extends CoreFeatureContext
{
    use DatabaseTransactions;

    /**
     * @Given I am on registration page
     */
    public function iAmOnRegistrationPage()
    {
        $this->visitPath('auth/register');
    }

    /**
     * @Given I submitted the form with all valid values
     */
    public function iSubmittedTheFormWithAllValidValues()
    {
        $this->fillField('name', 'Vinh Nguyen');
        $this->fillField('email', 'ngocvinh.nnv@gmail.com');
        $this->fillField('password', '123456');
        $this->fillField('password_confirmation', '123456');
        $this->pressButton('Sign Up');
    }

    /**
     * @Given I submitted the form with an unmatched password confirmation
     */
    public function iSubmittedTheFormWithAnUnmatchedPasswordConfirmation()
    {
        $this->fillField('name', 'Vinh Nguyen');
        $this->fillField('email', 'vinhnguyen@hust.com');
        $this->fillField('password', 'secret');
        $this->fillField('password_confirmation', 'secret-secret');
        $this->pressButton('Sign Up');
    }

    /**
     * @Given I submitted the form with an invalid username
     */
    public function iSubmittedTheFormWithAnInvalidUsername()
    {
        $this->fillField('name', 'Vinh Nguyen 111');
        $this->pressButton('Sign Up');
    }

    /**
     * @Given I submitted the form with an invalid email address
     */
    public function iSubmittedTheFormWithAnInvalidEmailAddress()
    {
        $this->fillField('email', 'foo@bar');
        $this->pressButton('Sign Up');
    }

    /**
     * @Given I submitted the form with a too short password
     */
    public function iSubmittedTheFormWithATooShortPassword()
    {
        $this->fillField('password', '123');
        $this->fillField('password_confirmation', '123');
        $this->pressButton('Sign Up');
    }
}
