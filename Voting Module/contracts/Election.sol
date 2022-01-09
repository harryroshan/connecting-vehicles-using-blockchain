 pragma solidity ^0.5.0;

contract Election {
    // Model a Candidate
    struct Candidate {
        uint id;
        string name;
        int voteCount;
    }

    // Store accounts that have voted
    mapping(address => bool) public voters;
    // Store Candidates
    // Fetch Candidate
    mapping(uint => Candidate) public candidates;
    // Store Candidates Count
    uint public candidatesCount;

    // voted event
    event votedEvent (
        uint indexed _candidateId
    );
    event downVotedEvent (
        uint indexed _candidateId
    );
    constructor () public {
        addCandidate("Accident Ocurred at 12:00pm");
        addCandidate("Accident Occurred at 5:00am");
    }

    function addCandidate (string memory _name) private {
        candidatesCount ++;
        candidates[candidatesCount] = Candidate(candidatesCount, _name, 0);
    }

    function vote (uint _candidateId) public {
        //require that they haven't voted before
        // require(voters[msg.sender],"not valid voter");

        // require a valid candidate
        require(_candidateId > 0 && _candidateId <= candidatesCount, "Candidate not valid");

        // record that voter has voted
        voters[msg.sender] = true;

        // update candidate vote Count
        candidates[_candidateId].voteCount ++;

        // trigger voted event
        emit votedEvent(_candidateId);
    }
    function downVote (uint _candidateId) public {
        //require that they haven't voted before
        // require(voters[msg.sender],"not valid voter");

        // require a valid candidate
        require(_candidateId > 0 && _candidateId <= candidatesCount, "Candidate not valid");

        // record that voter has voted
        voters[msg.sender] = true;

        // update candidate vote Count
        candidates[_candidateId].voteCount --;

        // trigger voted event
        emit votedEvent(_candidateId);
    }
}
